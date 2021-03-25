#!/bin/bash

max=0
min=0

while read -r line
do

        e=`echo "$line" | sed -n 's/.*ids: \[\(.*\)\]; errMsg:.*/\1/p'`
        # echo $e
        array=(${e//,/ })
        for var in ${array[@]}
        do
                #echo $var
                if [ $var -gt $max ] ; then
                        echo $var
                        max=$var
                fi
                if [ $var -lt $min ] || [ $min == 0 ] ; then
                        echo $var
                        min=$var
                fi
        done
done < httptest.log

echo "min:{$min} max:{$max}"
