# Multi-Zipcode Service API

This document provides details on how to use the Multi-Zipcode Service API for searching zip codes.

## API Endpoint

The request is sent to:


## Headers

The request requires the following headers:

- `X-MZS-ID`: API identification key
- `X-MZS-KEY`: API authentication key
- `Content-Type`: Specifies the format of the data (must be `application/json`)
- `Cookie`: Session authentication cookie

## Request Format

To search for a specific zip code, use the following cURL command:

```sh
curl --location 'http://localhost:8000/web/vanilla/multi-zipcode-service/api/v1/zipcode/search' \
--header 'X-MZS-ID: 1740097724' \
--header 'X-MZS-KEY: DA7FA2D3698F1242597DBF5D523E6' \
--header 'Content-Type: application/json' \
--header 'Cookie: PHPSESSID=7172a7ba9258c7d66f4cab9e76c19bdf' \
--data '{
    "zipcode": 82800270
}'


Feel free to modify the details based on your specific requirements. Let me know if you need any refinements!