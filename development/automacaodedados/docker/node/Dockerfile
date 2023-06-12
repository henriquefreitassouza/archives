FROM node:latest
LABEL "version"="1.0"

ENV HUGO_PORT="8080"
ENV HUGO_VERSION="0.91.0"

RUN mkdir -p /temp /src /dist /usr/local/bin  \
  && cd /temp \
  && wget https://github.com/gohugoio/hugo/releases/download/v${HUGO_VERSION}/hugo_extended_${HUGO_VERSION}_Linux-64bit.tar.gz \
  && tar -xvzf hugo_extended_${HUGO_VERSION}_Linux-64bit.tar.gz \
  && chmod +x hugo \
  && mv hugo /usr/local/bin/hugo \
  && rm -rf /temp \
  && hugo version

COPY ./run.sh /
COPY ./src /src

RUN chmod +x run.sh

WORKDIR /src

RUN npm cache clean -f \
  && npm install -g npm@latest gulp-cli@latest \
  && npm install --save-dev autoprefixer@latest cssnano@latest gray-matter@latest gulp@latest gulp-postcss@latest gulp-rename@latest gulp-uglify@latest lunr@latest purgecss@latest remove-markdown@latest tailwindcss@latest

WORKDIR /

ENTRYPOINT ["/run.sh"]
