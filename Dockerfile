FROM php:8.3-cli

# Configure the working directory
WORKDIR /var/www/html

# Copy all files to the container
COPY . .

# Configure the volume
VOLUME /var/www/html

# Expose the port 9000
EXPOSE 9000

# Run the PHP
CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/html/public"]