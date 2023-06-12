#!/bin/sh

cd /dist
rm -r *
cd /src
hugo --gc -d /dist -w &
gulp
