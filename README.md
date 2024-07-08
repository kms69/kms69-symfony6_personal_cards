# Symfony6 Personal Cards App

Symfony6 Personal Cards is a CRUD application for managing personal card records.

## Getting Started

### Prerequisites

Ensure you have the following installed:

•  PHP 7.4 or higher

•  Composer

•  MySQL or compatible database server


### Installation

1. [**Clone the repository:**](https://www.bing.com/search?form=SKPBOT&q=Clone%20the%20repository%3A)
```bash
git clone https://github.com/kms69/symfony6_personal_cards.git
cd symfony6_personal_cards

### Install Dependencies
composer install

### Configure Environment Variables
Create a .env.local file in the root directory and configure your database connection:

# > doctrine/doctrine-bundle
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
# < doctrine/doctrine-bundle

Replace db_user, db_password, and db_name with your actual database credentials.

### Create the Database
php bin/console doctrine:database:create

### Run Migrations
php bin/console doctrine:migrations:migrate

### Start the Symfony Server
symfony server:start

The application will be available at http://127.0.0.1:8000/personal_card/.

### API Endpoints
Personal Card Service
•  GET /personal_card - List all personal cards

•  GET /personal_card/{id} - Show details of a personal card

•  POST /personal_card - Create a new personal card

•  PUT /personal_card/{id} - Update an existing personal card

•  DELETE /personal_card/{id} - Delete a personal card

### Environment Variables
Ensure your .env.local file contains the following variables:

# > doctrine/doctrine-bundle
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
# < doctrine/doctrine-bundle

