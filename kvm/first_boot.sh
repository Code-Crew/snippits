#!/bin/bash
# This script will run the first time the virtual machine boots
# It is ran as root.

# Expire the user account
passwd -e teknix

# Install openssh-server
apt-get update
apt-get install -qqy --force-yes aptitude bash-completion man-db 
