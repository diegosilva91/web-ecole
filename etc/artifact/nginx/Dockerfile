#FROM node:14-alpine as node
FROM node:14 as node

#RUN apk add binutils python g++ file
#RUN apk add make

ARG MIX_SENTRY_VUE_DNS
ARG MIX_STRIPE_KEY
ARG MIX_GTM_ID

ENV MIX_SENTRY_VUE_DNS=$MIX_SENTRY_VUE_DNS
ENV MIX_STRIPE_KEY=$MIX_STRIPE_KEY
ENV MIX_GTM_ID=$MIX_GTM_ID

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY public /app/public
COPY webpack* ./

COPY resources resources

RUN npm run production

FROM nginx:1.17-alpine as nginx

ENV APP_ENV prod

WORKDIR /app

COPY etc/artifact/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --from=node /app/public /app/public
