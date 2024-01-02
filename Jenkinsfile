pipeline {
    agent any

    stages {
        stage('Setup & Start Services') {
            steps {
                script {
                    // Set the build number to the current git branch
                    currentBuild.displayName = env.GIT_BRANCH
                    // Copy .env.example to .env
                    sh 'cp .env.example .env'
                    // Run docker-compose to start your services
                    sh 'docker compose -f docker-compose.testing.yml up --force-recreate -d'
                }
            }
        }

        stage('Code Style Checks') {
            steps {
                script {
                    // Assuming your Laravel service is named 'app' in your docker-compose.yml
                    sh 'docker compose exec -T web ./vendor/bin/phpcs'
                }
            }
        }

        stage('Tests') {
            steps {
                script {
                    // Assuming your Laravel service is named 'app' in your docker-compose.yml
                    sh 'docker compose exec -T web php artisan test --coverage'
                }
            }
        }

        stage('Package Security Check') {
            steps {
                script {
                    sh 'docker compose exec -T web php artisan security-check:now'
                }
            }
        }
    }

    post {
        success {
            publishHTML([
                allowMissing: false,
                alwaysLinkToLastBuild: true,
                keepAll: true,
                reportDir: 'tests/Coverage/html',
                reportFiles: 'index.html',
                reportName: 'PHPUnit Test Coverage',
                reportTitles: '',
                useWrapperFileDirectly: true
            ])
        }
        always {
            // Stop and remove all containers and networks
            sh 'docker compose down --volumes --remove-orphans'
        }
    }
}
