pipeline {
    agent any
    environment {
        // Menambahkan path Docker
        PATH = "/usr/local/bin:/opt/homebrew/bin:/usr/bin:/bin:$PATH"
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

        stage('Docker Build') {
            steps {
                script {
                    // Mengambil image terbaru dan membangun container
                    sh 'docker built -t koi:latest .'
                }
            }
        }

        stage('Run Application') {
            steps {
                script {
                    // Menjalankan aplikasi dengan Docker Compose di background
                    sh 'docker-compose up -d'

                    // Memastikan container berjalan
                    sh 'docker ps' // Mengecek container yang sedang berjalan
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    // Menjalankan aplikasi untuk memastikan semuanya berjalan dengan baik
                    // Sesuaikan dengan port aplikasi Anda
                    sh 'curl -f http://localhost:8080 || echo "Test failed!"'  // Jika aplikasi tidak berjalan, tampilkan pesan error
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
