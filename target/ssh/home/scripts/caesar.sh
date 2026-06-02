#!/bin/bash

shift_string() {
    local input="$1"
    local offset="${2:-1}"
    local output=""

    for (( i=0; i<${#input}; i++ )); do
        char="${input:$i:1}"
        ascii=$(printf '%d' "'$char")

        # Shift by offset, wrapping within printable ASCII range (32-126)
        ascii=$(( (ascii - 32 + offset) % 95 ))

        # Handle negative modulo (bash can return negative results)
        if [[ $ascii -lt 0 ]]; then
            (( ascii += 95 ))
        fi

        (( ascii += 32 ))

        output+=$(printf "\\$(printf '%03o' $ascii)")
    done

    echo "$output"
}

if [[ -z "$1" ]]; then
    read -p "Enter string: " input
    read -p "Enter offset (default 1): " offset
    shift_string "$input" "${offset:-1}"
else
    shift_string "$1" "${2:-1}"
fi