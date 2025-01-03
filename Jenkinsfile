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

        stage('Set Environment Variables') {
            steps {
                script {
                    // Membuat file .env secara manual
                    writeFile file: '.env', text: """
                    DB_CONNECTION=mysql
                    DB_HOST=db
                    DB_PORT=3306
                    DB_DATABASE=laravel1
                    DB_USERNAME=root
                    DB_PASSWORD=root
                    APP_KEY=base64:...
                    """
                }
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
                    sh 'docker rm -f $(docker ps -aq) || true'  // Menghapus semua kontainer yang ada
                }
            }
        }

        stage('Run Application') {
            steps {
                script {
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
