pipeline {
    agent {
        label 'agente-ansible'
    }
    stages {
		// etapa 1: Origen del código de la aplicación a desplegar
        stage('Source') {
            steps {
				echo "Origen del código fuente de la aplicación"
                git 'https://github.com/emiliogh/git_tfm.git'
            }
        }
		// etapa 2 : Pruebas unitarias
        stage ('Ejecutar pruebas unitarias'){
            steps {
				echo "Ejecución de pruebas unitarias"
                sh 'cd src && ./vendor/bin/phpunit tests'
            }
        }
		// etapa 3: Validar conexión  ansible controlador - nodo
        stage('Validar conexión ansible controlador - nodo') {
            steps {
                echo "validar conexión ansible controlador con nodo"
				sshPublisher(publishers:
				[sshPublisherDesc(
				    configName:'AnsibleController',
					transfers: [
					    sshTransfer(
						cleanRemote:false,
						execCommand:'ansible-playbook playbook_ping.yml --limit nodo_prueba',
						execTimeout:120000
						)
					],
					usePromotionTimestamp: false,
					useWorkspaceInPromotion: false,
					verbose: false)
				])
            }
        }
		// etapa 4: Aprovisionamiento de nodo con docker
		stage('Aprovisionamiento de host con Docker') {
            steps {
                echo "instalación de Docker en el host"
				sshPublisher(publishers:
				[sshPublisherDesc(
				    configName:'AnsibleController',
					transfers: [
					    sshTransfer(
						cleanRemote:false,
						execCommand:'ansible-playbook docker.yaml --limit nodo_prueba',
						execTimeout:120000
						)
					],
					usePromotionTimestamp: false,
					useWorkspaceInPromotion: false,
					verbose: false)
				])
            }
        }
		// etapa 5: Despliegue mediante docker compose
		stage('Despliegue de la aplicación en docker') {
            steps {
                echo "Despliegue de la aplicación mediante docker compose"
				sshPublisher(publishers:
				[sshPublisherDesc(
				    configName:'AnsibleController',
					transfers: [
					    sshTransfer(
						cleanRemote:false,
						execCommand:'ansible-playbook deploy_compose.yml --limit nodo_prueba',
						execTimeout:120000
						)
					],
					usePromotionTimestamp: false,
					useWorkspaceInPromotion: false,
					verbose: false)
				])
            }
        }
    }
}
