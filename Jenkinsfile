node {

    env.PROD_HOST = "192.168.65.254"

    checkout scm

    stage("Build"){
        docker.image('php:8.4-cli').inside('-u root') {

            sh 'apt-get update'
            sh 'apt-get install -y git unzip curl libpng-dev libzip-dev zip'
            sh 'docker-php-ext-install gd zip'

            sh 'curl -sS https://getcomposer.org/installer | php'
            sh 'mv composer.phar /usr/local/bin/composer'

            sh 'git config --global --add safe.directory /var/jenkins_home/workspace/laravel-dev'

            sh 'composer install --no-interaction'
        }
    }

    stage("Testing"){
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }
// test

    stage("Deploy"){
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {

            sshagent (credentials: ['ssh-prod']) {

                sh 'mkdir -p ~/.ssh'
                sh 'ssh-keyscan -H "$PROD_HOST" >> ~/.ssh/known_hosts'

                sh '''
                rsync -rav --delete ./ \
                sakab@$PROD_HOST:/home/sakab/deploy/ \
                --exclude=.env \
                --exclude=storage \
                --exclude=.git
                '''
            }
        }
    }

}