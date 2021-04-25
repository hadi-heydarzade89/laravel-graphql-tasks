# How it works

Please create free account <a href="https://auth0.com/signup">from here</a>

if you don't have one yet. Then, from your <a href="https://manage.auth0.com/">Auth0 dashboard</a>, head to
the <a href="https://manage.auth0.com/#/apis">APIs section</a>, click on the Create API button, and fill the form as
follows:

- Name: "Laravel and GraphQL API"
- Identifier: https://laravel-graphql-api
- Signing Algorithm: RS256

<p>
Set public.htaccess with following value

RewriteEngine On
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
</p>

<p>
<b>Authorizing the GraphiQL Client</b>

To be able to fetch your GraphQL API again, you will need to issue, from the GraphiQL client, requests with access tokens. As mentioned before, the way you get an access token varies depending on what type of client you are developing. However, in this article, for testing purposes, you will use a test token.

To get this token, open the APIs section in your Auth0 dashboard, then click on the API you created ("Laravel and GraphQL API"). Now, click on the Test tab then, if you scroll down a little bit, you will see a button called Copy Token. Click on this button to get a copy of the access token in your clipboard.

</p>


Now, head back to the GraphiQL tool, click on the blue Edit HTTP Headers button, click on the Add Header button, then add the following header:

    Header name: Authorization
    Header value: Bearer eyJ...aEw
