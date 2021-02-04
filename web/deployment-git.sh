#!/bin/bash
# Deployment
printf "\n"
echo "Deployment to Young  Drupal "
printf "\n"

 git fetch git@github.com:reuven770/youngisrael.git  development:development &&   git --work-tree=/home/cars4lessny/public_html checkout -f development
#git log
pwd
printf "\n"
whoami

