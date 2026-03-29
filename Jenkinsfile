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
            chmod 700 ~/.ssh
            
            # Ambil fingerprint host agar tidak ditanya yes/no
            ssh-keyscan -H 192.168.0.119 >> ~/.ssh/known_hosts

            # Tambahkan flag -o BatchMode=yes agar tidak minta password (biar langsung error kalau key salah)
            ssh -o BatchMode=yes -o StrictHostKeyChecking=no sakab@192.168.0.119 "echo CONNECTED"

            # Rsync dengan opsi SSH khusus
            rsync -avz --delete \
            -e "ssh -o StrictHostKeyChecking=no" \
            ./ sakab@192.168.0.119:/home/sakab/flottie-app \
            --exclude=.git \
            --exclude=node_modules
            '''
        }
    }
}
}