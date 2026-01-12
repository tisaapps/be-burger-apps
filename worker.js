export default {
  async fetch(request) {
    const url = new URL(request.url)

    // GANTI DOMAIN INFINITYFREE KAMU
    const targetUrl = "https://tis.gt.tc" + url.pathname + url.search

    const response = await fetch(targetUrl, {
      method: request.method,
      headers: {
        "User-Agent": "Mozilla/5.0",
        "Accept": "application/json",
        "Content-Type": "application/json"
      },
      body: request.method !== "GET" ? await request.text() : null
    })

    return new Response(response.body, {
      status: response.status,
      headers: {
        "Access-Control-Allow-Origin": "*",
        "Content-Type": "application/json"
      }
    })
  }
}
