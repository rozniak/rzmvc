#!/bin/bash

#
# build-deb.sh - Debian Package Build Script
#
# This source-code is part of the rzmvc project by Oddmatics:
# <<https://www.oddmatics.uk>>
#
# Author(s): Rory Fewell <roryf@oddmatics.uk>
#

# Enable 'bash strict mode'
#     (http://redsymbol.net/articles/unofficial-bash-strict-mode/)
#
set -euo pipefail
IFS=$'\n\t'


#
# CONSTANTS
#
PACKAGE_META='./debian-control'

SOURCE_ROOT='..'
SOURCE_CORE_ROOT="${SOURCE_ROOT}/src/core"
SOURCE_LIBS_ROOT="${SOURCE_ROOT}/src/libs"

TARGET_ROOT='debian'
DEBIAN_ROOT="${TARGET_ROOT}/DEBIAN"
TARGET_CORE_ROOT="${TARGET_ROOT}/usr/share/rzmvc"
TARGET_LIBS_ROOT="${TARGET_ROOT}/usr/share/rzmvc/lib"
TARGET_PACKAGE_META="${DEBIAN_ROOT}/control"


#
# FUNCTIONS
#
build_core()
{
    mkdir -p $TARGET_CORE_ROOT

    cp "${SOURCE_CORE_ROOT}/htaccess" "${TARGET_CORE_ROOT}/.htaccess"
    cp "${SOURCE_CORE_ROOT}/rzmvc.php" $TARGET_CORE_ROOT
}

build_libs()
{
    mkdir -p $TARGET_LIBS_ROOT

    # Loop through libs directories - find library.json and combine to form target
    # PHP lib
    #
    for libdir in $SOURCE_LIBS_ROOT/*; do
        local library_json="${libdir}/library.json"

        if [ -f $library_json ]; then
            local library_name=$(jq -rM '.name' $library_json)
            local target_library="${TARGET_LIBS_ROOT}/${library_name}.php"
            
            for file in $(jq -rM '.files | .[]' $library_json); do
                local library_file="${libdir}/${file}"

                cat $library_file >> $target_library
            done
        fi
    done
}

check_running_dir()
{
    if [ ! -f './build-deb.sh' ]
    then
        echo "This script is intended to be executed from its origin directory."
        exit 1
    fi
}

finalize_build()
{
    # Set up DEBIAN dir
    #
    mkdir -p $DEBIAN_ROOT

    cp $PACKAGE_META $TARGET_PACKAGE_META
}

finish_build()
{
    fakeroot dpkg-deb -v --build $TARGET_ROOT

    mv debian.deb rzmvc.deb
}

prepare_build()
{
    if [ -d $TARGET_ROOT ]
    then
        rm -rf $TARGET_ROOT
    fi

    mkdir $TARGET_ROOT
}


#
# ENTRY POINT
#
check_running_dir
prepare_build
build_core
build_libs
finalize_build
finish_build
