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

<<<<<<< Updated upstream
        stage('Install Dependencies') {
            steps {
                script {
                    // Menyusun dan menginstall dependencies yang diperlukan dari Dockerfile atau package manager
                    // Menyesuaikan dengan jenis project (misalnya untuk Node.js, PHP, Python, dll)
                    sh 'docker-compose build'  // Jika menggunakan docker-compose untuk membangun image
                }
            }
        }

        stage('Run Application') {
=======
        stage('Build Docker Image') {
>>>>>>> Stashed changes
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
                    // Mengecek apakah Docker Compose sudah berjalan dan menghentikan jika ada
                    sh 'docker-compose down || true'  // Menghentikan dan menghapus kontainer jika ada
                    sh 'docker-compose up -d'         // Menjalankan aplikasi dengan Docker Compose
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