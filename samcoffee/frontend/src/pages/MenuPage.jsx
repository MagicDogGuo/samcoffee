import Menu from '../components/Menu.jsx'

export default function MenuPage() {
  return (
    <main className="max-w-6xl mx-auto px-6">
      <section id="menu" className="py-12">
        <h2 className="text-center text-4xl text-coffee-brown mb-8">Our Menu</h2>
        <Menu />
      </section>
    </main>
  )
}
