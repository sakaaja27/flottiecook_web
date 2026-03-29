node {
    checkout scm

    // deploy env dev
    stage("Build") {
        docker.image('senasindhabramasta/php-8.4:latest').inside('-u root') {
            sh 'rm composer.lock'
            sh 'composer install'
        }
    }

    // Testing
    docker.image('ubuntu').inside('-u root') {
        sh 'echo "Ini adalah test"'
    }

    // deploy env prod
    docker.image('agung3wi/alpine-rsync:1.1').inside('--add-host=host.docker.internal:host-gateway -u root') {
        sshagent (credentials: ['ssh-prod']) {
            sh 'mkdir -p ~/.ssh'
            sh "ssh-keyscan -H $PROD_HOST > ~/.ssh/known_hosts"
            sh "rsync -rav --delete ./laravel/ sakab@$PROD_HOST:/home/sakab/prod.kelasdevops.xyz/ --exclude=.env --exclude=storage --exclude=.git"
        }
    }
}