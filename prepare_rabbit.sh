#!/bin/bash

echo "# Preparing vhost"
rabbitmqctl delete_vhost bench || true
rabbitmqctl add_vhost bench
rabbitmqctl set_permissions -p bench guest ".*" ".*" ".*"

echo "# Declaring mapping"
rabbitmqadmin declare exchange name=bench type=direct auto_delete=false durable=true --vhost=bench
rabbitmqadmin declare queue name=bench auto_delete=false durable=true --vhost=bench
rabbitmqadmin declare binding source=bench routing_key=bench destination=bench --vhost=bench

echo "# Create some messages"
for i in `seq 1 100000`
do
    rabbitmqadmin publish routing_key="bench" payload="message$i" exchange="bench" --vhost=bench
done
