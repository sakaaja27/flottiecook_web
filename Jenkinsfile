node {
    env.PROD_HOST = "192.168.1.14"

    checkout scm

    stage("Build") {
        docker.image('senasindhabramasta/php-8.4:latest').inside('-u root') {
            sh 'git config --global --add safe.directory /var/jenkins_home/workspace/flottiecook-dev'
            sh 'composer install --no-interaction --prefer-dist'
        }
    }

    stage("Test") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }

    stage("Deploy") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            sshagent (credentials: ['ssh-prod']) {
                sh 'mkdir -p ~/.ssh'
                sh "ssh-keyscan -H $PROD_HOST >> ~/.ssh/known_hosts"

                sh """
                set -ex

                echo "Deploy ke: $PROD_HOST"

                ssh -o StrictHostKeyChecking=no sakab@$PROD_HOST "echo CONNECTED"

                rsync -rav --delete \
                -e "ssh -o StrictHostKeyChecking=no" \
                ./ sakab@$PROD_HOST:/home/sakab/prod.kelasdevops.xyz/ \
                --exclude=.env \
                --exclude=storage \
                --exclude=.git
                """
            }
        }
    }
}