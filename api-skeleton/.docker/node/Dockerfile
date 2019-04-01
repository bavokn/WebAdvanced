FROM node:8.15.0-alpine

LABEL maintainer="Ghlen Nagels <ghlen@pm.me>"

USER node

WORKDIR /home/node

RUN mkdir tmp app

WORKDIR tmp
COPY package.json  package-lock.jso[n] ./
RUN npm install --no-optional

WORKDIR ../app
COPY *.js .en[v] package.json package-lock.jso[n] .babelrc ./
COPY --chown=node:node resources/ resources/
COPY --chown=node:node public/ public/

RUN npm install --no-optional \
 && rm -Rf ../tmp

CMD ["sh", "-c", "npm run $APP_NPM_RUN_MODE"]

