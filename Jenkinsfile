pipeline {
    agent any
    environment {
        PATH = "/usr/local/bin:/opt/homebrew/bin:/usr/bin:/bin:$PATH"
        GITHUB_REPO = 'https://github.com/wangxixi25/TUBES-KOI-KOMPUTASI-AWAN.git'
        DISCORD_WEBHOOK_URL = 'https://discord.com/api/webhooks/1324751924209254622/cymdDBjGo5EAyzjtxlZiVhBhulkDRvkogNQhQnGQYxbLiKFqfPeg0ZeKhyaTyNYM8dpw'
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
                    sh 'docker build -t koi:latest .' 
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
            script {
                // Kirim notifikasi ke Discord jika pipeline berhasil
                sh """
                curl -X POST -H "Content-Type: application/json" \
                -d '{
                    "content": "Pipeline berhasil dijalankan! ✅",
                    "embeds": [
                        {
                            "title": "Pipeline Success",
                            "description": "Pipeline untuk repository ${GITHUB_REPO} telah berhasil dijalankan.",
                            "color": 3066993
                        }
                    ]
                }' ${DISCORD_WEBHOOK_URL}
                """
            }
        }

        failure {
            echo 'Pipeline gagal.'
        }
    }
}
