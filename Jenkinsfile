node {
    checkout scm

    stage("Build") {
        docker.image('senasindhabramasta/php-8.4:latest').inside('-u root') {
            sh 'git config --global --add safe.directory /var/jenkins_home/workspace/flottiecook-devops'
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
                sh '''
                mkdir -p ~/.ssh
                ssh-keyscan -H 192.168.0.119 >> ~/.ssh/known_hosts

                rsync -avz --delete ./ \
                sakab@192.168.0.119:/home/sakab/laravel-app \
                --exclude=.git \
                --exclude=node_modules
                '''
            }
        }
    }
}