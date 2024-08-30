#!/bin/bash

# Check if an image filename is provided as an argument
if [ -z "$1" ]; then
    echo "Usage: $0 {image_filename}"
    exit 1
fi

# Get the image filename from the argument
img="$1"

# Check if the file exists
if [ ! -f "$img" ]; then
    echo "File not found: $img"
    exit 1
fi

# Optimize and/or convert the image based on its extension
case "${img##*.}" in
    (jpg|jpeg)
        echo "Optimizing JPEG: $img"
        convert "$img" -strip -sampling-factor 4:2:0 -quality 85 -interlace JPEG -colorspace RGB "$img"
        echo "Converting JPEG to WebP: $img"
        convert "$img" -quality 80 "${img%.*}.webp"
        ;;
    (png)
        echo "Optimizing PNG: $img"
        convert "$img" -strip -define png:compression-level=9 "$img"
        echo "Converting PNG to WebP: $img"
        convert "$img" -quality 80 "${img%.*}.webp"
        ;;
    (*)
        echo "Unsupported file format: $img"
        exit 1
        ;;
esac

echo "Optimization and conversion complete for $img."
