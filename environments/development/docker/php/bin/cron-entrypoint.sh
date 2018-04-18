#!/usr/bin/env bash

set -x

touch /var/log/cron.log || true
tail -f /var/log/cron.log &

set +x

exec "$@"