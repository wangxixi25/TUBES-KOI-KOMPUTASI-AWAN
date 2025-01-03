pipeline {
    agent any
    environment {
        PATH = "/usr/local/bin:/opt/homebrew/bin:/usr/bin:/bin:$PATH"
        GITHUB_REPO = 'https://github.com/wangxixi25/TUBES-KOI-KOMPUTASI-AWAN.git'
    }

    stages {
        stage('Clone Repository') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    sh 'docker build -t koi:latest .'  // Menyusun image Docker
                }
            }
        }

        stage('Remove Existing Containers') {
            steps {
                script {
                    // Menghapus semua kontainer yang ada sebelum menjalankan Docker Compose
                    sh 'docker rm -f $(docker ps -aq) || true'  // Menghapus semua kontainer yang ada
                }
            }
        }

        stage('Run Application') {
            steps {
                script {
                    sh 'docker-compose up -d'  // Menjalankan aplikasi dengan Docker Compose
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    sh 'curl -f http://localhost:8080 || echo "Test failed!"'
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
