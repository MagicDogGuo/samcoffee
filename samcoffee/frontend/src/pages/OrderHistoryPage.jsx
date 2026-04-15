import OrderHistory from '../components/OrderHistory.jsx'

export default function OrderHistoryPage() {
  return (
    <main className="max-w-6xl mx-auto px-6">
      <section id="order-history" className="py-12">
        <h2 className="text-center text-4xl text-coffee-brown mb-8">Your Order History</h2>
        <OrderHistory />
      </section>
    </main>
  )
}
