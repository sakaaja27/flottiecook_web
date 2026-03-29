node {
    checkout scm

    // deploy env dev
    stage("Build") {
        docker.image('php-8.4').inside('-u root') {
            sh 'rm composer.lock'
            sh 'composer install'
        }
    }

    // Testing
    docker.image('ubuntu').inside('-u root') {
        sh 'echo "Ini adalah test"'
    }
}