# Use a specific Node.js version
FROM node:16-alpine

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package.json package-lock.json ./
RUN npm install

# Copy the entire project
COPY . .

# Expose the desired port
EXPOSE 8000

# Start the application
CMD ["npm", "start"]
