pipeline {
    agent any
    environment {
        PATH = "/usr/local/bin/docker"
    }
    stages {
        stage('Check Docker') {
            steps {
                sh 'docker --version'
            }
        }
    }
}
