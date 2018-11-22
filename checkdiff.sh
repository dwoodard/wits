#!/bin/bash
WATCH_FILES=(composer.json package.json Dockerfile.base)

for i in ${WATCH_FILES[@]}; do

    git whatchanged -n1 | grep ${i}

    if [ $? -eq 0 ]; then

        docker build --no-cache -t wits_base -f Dockerfile.base .

        exit 0

	fi
done