#!/usr/bin/env bash
#
# anax/remserver
#
# Integrate the REM server onto an existing anax installation.
#

# Copy the configuration files
rsync -av vendor/graudusk/callurl/config ./

# Copy the view files
rsync -av vendor/graudusk/callurl/view ./

# Copy the htdocs files
rsync -av vendor/graudusk/callurl/htdocs/ ./htdocs

# Copy the documentation
rsync -av vendor/anax/remserver/content/index.md ./content/remserver-api.md
