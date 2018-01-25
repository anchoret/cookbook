#!/bin/sh

dc_exec_command()
{
    DOCKER_COMPOSE_EXEC_COMMAND="docker-compose exec -u laravel workspace $@"

    while :
    do
        WORKSPACE_SERVICE_STATUS=$(docker-compose exec workspace printf '%s' 1 2>/dev/null)

        if [ "$WORKSPACE_SERVICE_STATUS" != "1" ]; then
            DOCKER_COMPOSE_UP_COMMAND="docker-compose up -d --no-deps workspace"
            printf '%s\n' "Before you run any command you should start workspace service."
            printf '%s' "Start workspace service? (docker-compose up -d --no-deps workspace)[y/N]:"
            read ANSWER

            if [ "$ANSWER" = "y" -o "$ANSWER" = "Y" ]; then
                 $DOCKER_COMPOSE_UP_COMMAND
            else
                exit 0
            fi

        else
            $DOCKER_COMPOSE_EXEC_COMMAND
            exit 0
        fi
    done
}
