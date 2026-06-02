#!/bin/bash
sudo chown -R 100:101 /etc/docker/infra/bind9
sudo chown -R 999:999 /etc/docker/infra/mysql
sudo chown -R 101:101 /etc/docker/infra/nginx
sudo chown -R 82:82 /etc/docker/infra/www
sudo chown -R 82:82 /etc/docker/infra/php
sudo chown -R 999:999 /etc/docker/target/mysql
sudo chown -R 101:101 /etc/docker/target/nginx
sudo chown -R 82:82 /etc/docker/target/www
sudo chown -R 82:82 /etc/docker/target/php
sudo chown -R 1001:1001 /etc/docker/target/ssh/home
sudo chmod -R 700 /etc/docker/target/ssh/home