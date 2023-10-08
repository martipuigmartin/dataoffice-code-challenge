.PHONY: up
up:
	 docker compose up -d
.PHONY: stop
stop:
	docker compose stop

.PHONY: down
down:
	docker compose down

.PHONY: build
build:
	docker compose build --no-cache

.PHONY: restart
restart: stop up

.PHONY: card-fetch
card-fetch:
	docker compose exec php vendor/bin/bref local CardFetcher '{"Records":[{"eventVersion":"2.0","eventSource":"aws:s3","awsRegion":"","eventTime":"2023-10-03T11:18:29.007Z","eventName":"s3:ObjectCreated:Put","userIdentity":{"principalId":"root"},"requestParameters":{"principalId":"root","region":"","sourceIPAddress":"172.26.0.7"},"responseElements":{"content-length":"0","x-amz-request-id":"178A94E1DAE23A07","x-minio-deployment-id":"5e860383-8e32-4706-8aca-423186f08c38","x-minio-origin-endpoint":"http://172.26.0.7:9000"},"s3":{"s3SchemaVersion":"1.0","configurationId":"Config","bucket":{"name":"dataoffice-code-challenge","ownerIdentity":{"principalId":"root"},"arn":"arn:aws:s3:::dataoffice-code-challenge"},"object":{"key":"AllPrintings.json","size":168540130,"eTag":"2f1d8164041d0e3ba60673782fe6a62c","contentType":"application/json","userMetadata":{"content-type":"application/json"},"sequencer":"178A94E23993EAEA"}},"source":{"host":"172.26.0.7","port":"","userAgent":"MinIO (linux; arm64) minio-go/v7.0.30"}}]}'

.PHONY: psalm-lint
psalm-lint:
	docker compose exec php vendor/bin/psalm

.PHONY: cs-fix
cs-fix:
	docker compose exec php vendor/bin/php-cs-fixer fix src
