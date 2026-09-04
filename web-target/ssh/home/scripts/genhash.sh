#!/usr/bin/env bash

random_val=$(od -An -tx1 -N32 /dev/urandom | tr -d ' \n')

current_time=$(date +%s%N)

random_val+=$current_time

md5_hash=$(printf '%s' "$random_val" | md5sum | awk '{print $1}')

block=()
for (( i=0; i<${#md5_hash}; i+=8 )); do
    block+=("${md5_hash:$i:8}")
done

index=$(od -An -tu4 -N4 /dev/urandom | tr -d ' \n')
index=$(( index % 4 ))

echo "${block[$index]}" | awk '{print toupper($0)}' 