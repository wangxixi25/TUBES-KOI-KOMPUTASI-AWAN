pipeline {
    agent any
    stages {
        stage('Check Docker') {
            steps {
                sh 'docker --version'
                sh 'docker-compose --version'
            }
        }
        stage('Build Docker Image') {
            steps {
                sh '/bin/sh -c "docker-compose build"'
            }
        }
    }
}
