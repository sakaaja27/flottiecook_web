node {
    checkout scm

    stage("Build Backend") {
        docker.image('senasindhabramasta/php-8.4:latest').inside('-u root') {
            sh '''
                git config --global --add safe.directory $WORKSPACE
                composer install --no-interaction --prefer-dist --no-dev
            '''
        }
    }

    stage("Build Frontend") {
        docker.image('node:20-alpine').inside('-u root') {
            sh '''
                npm install
                npm run build
                ls -lah public/build || true
            '''
        }
    }

    stage("Test") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Test OK"'
        }
    }

    stage("Deploy") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            sshagent(credentials: ['ssh-prod']) {
                sh '''
                    mkdir -p ~/.ssh
                    ssh-keyscan -H "$PROD_HOST" >> ~/.ssh/known_hosts

                    rsync -rav --delete \
                      --exclude=.env \
                      --exclude=node_modules \
                      --exclude=.git \
                      ./ "sakab@$PROD_HOST:/home/sakab/prod.kelasdevops.xyz/"
                '''
            }
        }
    }

    stage("Post Deploy Setup") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            sshagent(credentials: ['ssh-prod']) {
                sh '''
                    ssh sakab@$PROD_HOST "
                        cd /home/sakab/prod.kelasdevops.xyz && \
                        php artisan storage:link || true && \
                        php artisan config:cache || true && \
                        php artisan route:cache || true && \
                        php artisan view:cache || true
                    "
                '''
            }
        }
    }
}