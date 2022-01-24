### Hello World

### Autoryzacja

* klucz prywatny (id_student)
* ssh agent -> eval `ssh-agent`
* ssh-add ~/id_student
* fraza -> brak

### test connection
1. Maszyna
2. ``ssh ec2-user@{ip_maszyny}``

### Checkpoint -> instalacja wordpress
install wp step by step

### Requirements
- php > 7.4
- MariaDB > 10.1
- Apache

1. install

   ``sudo yum search apache | grep -i server``
 
   ``sudo yumm install httpd.x86_64``
 
   ``sudo systemctl start httpd``

2. config apache 
```
<VirtualHost *:80>
    DocumentRoot "/var/www/blog"
    DirectoryIndex index.html
</VirtualHost>
```
4. wd download

    ``curl https://pl.wordpress.org/latest-pl_PL.tar.gz ``

5. put wp file in destination dir

    ``mv wordpress/* /var/www/blog/``

6. PHP ->
    1. enable EPEL repo
    
        `` yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm``

    2. enable remi:

        `` yum install https://rpms.remirepo.net/enterprise/remi-release-7.rpm``
    
    3. install packages 
    
        `` yum install php80 php80-php php80-php-mysqlnd php80-php-pecl-mysql``

7. MariaDB
    1. MariaBD dir conf

        `` /etc/yum.repos.d/MariaDB.repo``

        ```
        # MariaDB 10.6 CentOS repository list - created 2021-12-18 11:19 UTC
        # https://mariadb.org/download/
        [mariadb]
        name = MariaDB
        baseurl = https://ftp.icm.edu.pl/pub/unix/database/mariadb/yum/10.6/centos7-amd64
        gpgkey=https://ftp.icm.edu.pl/pub/unix/database/mariadb/yum/RPM-GPG-KEY-MariaDB
        gpgcheck=1
        ```
    2. Install server
    
        `` sudo yum install MariaDB-server MariaDB-client ``

8. Create DB user 

```
create database databasename;

create user 'user' identified by 'password';
grant all privileges on databasename.* to 'user'@localhost identified by 'password';
grant all privileges on databasename.* to 'user'@host;
grant all privileges on databasename.* to 'user'@%;

FLUSH PRIVILEGES;
```

9. Put db config in wp -config

    ``cp wp-config-sample.php wp-config.php``


10. Create ansible playbook

    - define hosts.ini
    - create yaml file

``` 
  hosts: blog_nodes
  become: yes
  vars:
    WP_URL: https://pl.wordpress.org/latest-pl_PL.tar.gz
    EPEL_REPO_URL: https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
    REMI_REPO_URL: https://rpms.remirepo.net/enterprise/remi-release-7.rpm
    DB_NAME: blog
    DB_USER: blog
    DB_PW: blog!
  tasks:
    - name: "Lets create Hello world file"
      file:
        path: ~/hello_world.txt
        state: touch
    - name: "Install apche server"
      yum:
        name: httpd
        state: present
    - name: "put apache cfg into etc"
      copy:
        src: files/httpd-vhost.conf
        dest: /etc/httpd/conf.d/blog.conf
    - name: "Extract WP installation"
      unarchive:
        src: "{{ WP_URL }}"
        dest: /var/www
        remote_src: yes
    ### PHP RELATED
    - name: install epel repo
      yum:
        name: "{{ EPEL_REPO_URL }}"
        state: present
    - name: install php repo
      yum:
        name: "{{ REMI_REPO_URL }}"
        state: present
    - name: install php packages
      yum:
        name: 
          - php80
          - php80-php
          - php80-php-mysqlnd
          - php80-php-pecl-mysql
        state: present
    - name: "add mariadb repo cfg to yum conf"
      copy:
        src: files/mariadb.repo
        dest: /etc/yum.repos.d/Mariadb.repo
    - name: "install mariadb server"
      yum:
        name: 
          - MariaDB-server
          - MariaDB-client
          - MySQL-python
    - name: "start mariadb server"
      service:
        name: mariadb
        state: started
        enabled: yes
    - name: "create db"
      mysql_db:
        name: "{{ DB_NAME }}"
        state: present
    - name: "create user an grant privileges"
      mysql_user:
        name: "{{ DB_USER }}"
        password: "{{ DB_PW }}"
        priv: "{{ DB_NAME }}.*:ALL"
        state: present
    - name: "put wp config"
      template:
        src: files/wp-config.php
        dest: /var/www/wordpress/wp-config.php
    ## RESTART APACHE
    - name: "restart apache server"
      service:
        name: httpd
        state: restarted
        enabled: yes
```

### ScreenShot 

21.01.2022 niestety nie mam możliwości utworzenia instancji w AWS

![Screen](https://user-images.githubusercontent.com/56737374/150852385-e768b592-a162-4812-a076-277eeeca9e43.png)
![Sceen_WordPress](https://user-images.githubusercontent.com/56737374/150852697-85098236-f54d-486b-be1f-d8754fad81e6.JPG)
