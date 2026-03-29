node {
    checkout scm

    stage("Build") {
        docker.image('senasindhabramasta/php-8.4:latest').inside('-u root') {
            sh 'git config --global --add safe.directory /var/jenkins_home/workspace/flottiecook-devops'
            sh 'composer install --no-interaction --prefer-dist'
        }
    }

    stage("Build Frontend") {
        docker.image('node:20-alpine').inside('-u root') {
            sh 'npm install'
            sh 'npm run build'
        }
    }

    stage("Test") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }

    stage("Deploy") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            sshagent(credentials: ['ssh-prod']) {
                sh 'mkdir -p ~/.ssh'
                sh 'ssh-keyscan -H "$PROD_HOST" >> ~/.ssh/known_hosts'
                sh '''
                    rsync -rav --delete \
                      --exclude=.env \
                      --exclude=storage \
                      --exclude=.git \
                      ./ "sakab@$PROD_HOST:/home/sakab/prod.kelasdevops.xyz/"
                '''
            }
        }
    }
}