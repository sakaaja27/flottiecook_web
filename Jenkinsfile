node {
    stage("Checkout") {
        checkout scm
    }

    stage("Build") {
        docker.image('composer:2').inside('-u root') {
            sh 'composer install --no-interaction'
        }
    }

    stage("Deploy") {
        docker.image('alpine').inside('-u root') {
            sshagent (credentials: ['ssh-prod']) {
                sh '''
                mkdir -p ~/.ssh
                ssh-keyscan -H 192.168.0.119 >> ~/.ssh/known_hosts

                rsync -avz --delete ./ \
                sakab@192.168.0.119:/home/sakab/flottie-app \
                --exclude=.git \
                --exclude=vendor \
                --exclude=node_modules
                '''
            }
        }
    }
}