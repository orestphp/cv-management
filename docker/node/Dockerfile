FROM node:20.9.0-alpine

WORKDIR /app

ENV PYTHONUNBUFFERED=1
RUN apk update && \
    apk add --no-cache build-base python3 py3-pip && \
    ln -sf python3 /usr/bin/python && \
    pip3 install --no-cache-dir --upgrade pip setuptools

# Clean up Yarn installation conflicts
RUN rm -f /usr/local/bin/yarnpkg && \
    rm -f /usr/local/bin/yarn && \
    npm install -g yarn@1.21.1

# Ensure user 'node' is used
RUN chown -R node:node /app
USER node

# Copy package.json and install dependencies before copying full code
COPY --chown=node:node frontend/package.json frontend/yarn.lock ./
RUN yarn install --frozen-lockfile

# Copy the rest of the frontend source code
COPY --chown=node:node frontend ./

RUN yarn install

CMD ["yarn", "run", "dev"]