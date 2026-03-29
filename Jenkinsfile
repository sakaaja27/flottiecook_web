node {
    checkout scm

    // deploy env dev
    stage("Build") {
        docker.image('composer:2.7').inside('-u root') {
            sh 'rm composer.lock'
            sh 'composer install'
        }
    }

    // Testing
    docker.image('ubuntu').inside('-u root') {
        sh 'echo "Ini adalah test"'
    }
}