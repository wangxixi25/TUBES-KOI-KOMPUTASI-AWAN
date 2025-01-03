pipeline {
    agent any
    environment {
        PATH = "/usr/local/bin/docker-compose"
    }
    stages {
        stage('Build Docker Image') {
            steps {
                script {
                    // Build Docker image using docker-compose
                    sh 'docker buid -t koi:latest .'
                }
            }
        }
        stage('Run Docker Container') {
            steps {
                script {
                    // Run Docker container using docker-compose
                    sh 'docker-compose up -d'
                }
            }
        }
        stage('Test Docker Application') {
            steps {
                script {
                    // Run your test commands here
                    sh 'docker ps'
                }
            }
        }
    }
}
