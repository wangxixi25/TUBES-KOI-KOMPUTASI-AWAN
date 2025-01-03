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

        stage('Set Environment Variables') {
            steps {
                script {
                    writeFile file: '.env', text: """
                    DB_CONNECTION=mysql
                    DB_HOST=db
                    DB_PORT=3306
                    DB_DATABASE=laravel1
                    DB_USERNAME=root
                    DB_PASSWORD=root
                    APP_KEY=base64:t2re30r4n/lZWHgVLEkTbbTgl2Y9cskLF9MtAJHQpLQ=
                    """
                }
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
                    sh 'docker rm -f $(docker ps -aq) || true'
                }
            }
        }

        stage('Run Application') {
            steps {
                script {
                    sh 'docker-compose down || true'
                    sh 'docker-compose up -d'
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    sh 'curl -f http://localhost:8000 || echo "Test failed!"'
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
                def payload = """
                {
                    "content": "Pipeline berhasil dijalankan! ✅",
                    "embeds": [
                        {
                            "title": "Pipeline Success",
                            "description": "Pipeline untuk repository ${GITHUB_REPO} telah berhasil dijalankan.",
                            "color": 3066993
                        }
                    ]
                }
                """
                sh "curl -X POST -H 'Content-Type: application/json' -d '${payload}' ${DISCORD_WEBHOOK_URL}"
            }
        }

        failure {
            script {
                // Kirim notifikasi ke Discord jika pipeline gagal
                def payload = """
                {
                    "content": "Pipeline gagal. ❌",
                    "embeds": [
                        {
                            "title": "Pipeline Failure",
                            "description": "Pipeline untuk repository ${GITHUB_REPO} gagal dijalankan. Silakan periksa log.",
                            "color": 15158332
                        }
                    ]
                }
                """
                sh "curl -X POST -H 'Content-Type: application/json' -d '${payload}' ${DISCORD_WEBHOOK_URL}"
            }
        }
    }
}
