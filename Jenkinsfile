pipeline {
    agent any

    environment {
        // URL GitHub Repository
        GITHUB_REPO = 'https://github.com/wangxixi25/TUBES-KOI-KOMPUTASI-AWAN.git'
    }

    stages {
        stage('Clone Repository') {
            steps {
                // Clone repository GitHub
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    // Menyusun dan menginstall dependencies yang diperlukan dari Dockerfile atau package manager
                    // Menyesuaikan dengan jenis project (misalnya untuk Node.js, PHP, Python, dll)
                    bat 'docker-compose build'  // Jika menggunakan docker-compose untuk membangun image
                }
            }
        }

        stage('Run Application') {
            steps {
                script {
                    // Menjalankan aplikasi dengan Docker Compose atau cara lain sesuai dengan proyek
                    bat 'docker-compose up -d'  // Jika menggunakan Docker Compose
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    // Menjalankan aplikasi untuk memastikan semuanya berjalan dengan baik
                    // Misalnya menjalankan curl untuk memastikan server berjalan
                    bat 'curl http://localhost:8080'  // Sesuaikan dengan port aplikasi Anda
                }
            }
        }

        stage('Notify Success') {
            steps {
                script {
                    echo 'Aplikasi berhasil dijalankan!'
                    // Kirim notifikasi sukses ke Discord atau lainnya jika diperlukan
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
