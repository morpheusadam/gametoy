# GameToy

GameToy is a WordPress plugin that provides a RESTful API for game-related data. It allows you to manage and retrieve game information through a simple and easy-to-use API.

## Features

- RESTful API for game data
- Manage games, players, and scores
- Secure API endpoints with authentication
- Easy integration with other systems

## Prerequisites

- WordPress 5.0 or higher
- PHP 7.0 or higher

## Installation

1. Download the plugin zip file from the [releases page](https://github.com/yourusername/gametoy/releases).

2. In your WordPress admin dashboard, go to `Plugins` > `Add New` > `Upload Plugin`.

3. Choose the downloaded zip file and click `Install Now`.

4. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. Go to the GameToy settings page in your WordPress admin dashboard to configure the plugin.

2. Use the following API endpoints to manage and retrieve game data:

    - **Get all games:**
        ```http
        GET /wp-json/gametoy/v1/games
        ```

    - **Get a single game:**
        ```http
        GET /wp-json/gametoy/v1/games/{id}
        ```

    - **Create a new game:**
        ```http
        POST /wp-json/gametoy/v1/games
        ```

    - **Update a game:**
        ```http
        PUT /wp-json/gametoy/v1/games/{id}
        ```

    - **Delete a game:**
        ```http
        DELETE /wp-json/gametoy/v1/games/{id}
        ```

3. Authentication is required for creating, updating, and deleting game data. Use WordPress REST API authentication methods such as application passwords or OAuth.

## Project Structure
