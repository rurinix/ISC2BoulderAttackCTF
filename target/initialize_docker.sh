#!/bin/bash
docker compose build
docker compose pull
docker compose up -d