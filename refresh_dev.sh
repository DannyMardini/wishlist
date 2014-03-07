#!/bin/bash
#This script will refresh your database fixture and entities.
set -e

destructive=false

ShowUsage()
{
    cat << EOF
    usage: $0 [-d]

    Update database with changes using Doctrine.

    OPTIONS:
        -d  Destructive refresh. *CAUTION* This option will drop the database
            and reload data fixtures.
EOF
}

while getopts ":dh" OPTION
do
    case $OPTION in
        d)
            destructive=true
            ;;
        h)
            ShowUsage
            exit
            ;;
        ?)
            echo "Unknown option - $OPTION"
            ShowUsage
            exit
            ;;
    esac
done

echo "Generating entities..."
php app/console generate:doctrine:entities Wishlist

if [ $destructive = true ]; then
    echo "Dropping Database..."
    php app/console doctrine:schema:drop --force
fi

echo "Updating Database..."
php app/console doctrine:schema:update --force

if [ $destructive = true ]; then
    echo "Loading Fixtures..."
    sed -i '' 's/\(DROP PROCEDURE [A-z;]*\)/# \1/' src/Wishlist/CoreBundle/DataFixtures/SQL/StoredProcedures.sql
    mysql -uroot < src/Wishlist/CoreBundle/DataFixtures/SQL/StoredProcedures.sql
    sed -i '' 's/# \(DROP PROCEDURE [A-z;]*\)/\1/' src/Wishlist/CoreBundle/DataFixtures/SQL/StoredProcedures.sql
    php app/console doctrine:fixtures:load
fi

echo "Updating assets..."
php app/console assetic:dump --env=prod --no-debug -v

exit 0

