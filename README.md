# Symfony 8 REST API Boilerplate

A modern, production-ready REST API starter template built with Symfony 8, high-performance **FrankenPHP** application server, JWT Authentication, and MongoDB for secure session/token management.

## Features
- **Symfony 8** Core & Modern Security System
- **FrankenPHP** Application Server (integrated Caddy, HTTP/3, and Worker-ready architecture)
- **JWT Authentication** (via LexikJWTAuthenticationBundle)
- **Secure Token Rotation** (Refresh Tokens via GesdinetJWTRefreshTokenBundle)
- **MongoDB ODM Store** for high-performance session tracking and refresh tokens with automatic TTL database expiration
- **PostgreSQL 16** for core relational data
- **Production-Ready Docker Stack** (PostgreSQL, MongoDB, with future support infrastructure for Valkey/Redis and RabbitMQ)

## Quick Start

1. **Clone the repository:**
   ```bash
   git clone <your-repository-url>
   cd <project-folder>
   ```

2. **Build and start FrankenPHP and database containers:**
   ```bash
   docker compose up -d --build
   ```

3. **Generate JWT Cryptographic Keys:**
   Run the native Symfony command inside the FrankenPHP container to automatically generate the keypair:
   ```bash
   docker compose exec app bin/console lexik:jwt:generate-keypair
   ```

4. **Initialize MongoDB Schema & TTL Indexes:**
   ```bash
   docker compose exec app bin/console doctrine:mongodb:schema:create
   ```

Your API is now up and running:
- **HTTPS:** `https://localhost:8443`
