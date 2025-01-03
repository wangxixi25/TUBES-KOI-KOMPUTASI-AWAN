pipeline {
    agent any

    environment {
        PATH = "/usr/local/bin/docker-compose"  // Menambahkan lokasi docker-compose ke PATH
    }

    stages {
        stage('Check Docker Compose') {
            steps {
                script {
                    sh 'which docker-compose'  // Memastikan docker-compose dapat ditemukan
                }
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    sh 'docker-compose build'
                }
            }
        }

        stage('Run Application') {
            steps {
                script {
                    sh 'docker-compose up -d'
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    sh 'curl http://localhost:8080'
                }
            }
        }

        stage('Notify Success') {
            steps {
                script {
                    echo 'Aplikasi berhasil dijalankan!'
                }
            }
        }
    }

    post {
        success {
            echo 'Pipeline berhasil dijalankan!'
        }

        failure {
            echo 'Pipeline gagal.'
        }
    }
}
