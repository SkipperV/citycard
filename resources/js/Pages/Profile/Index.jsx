import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from "@inertiajs/react";
import Card from "@/Pages/Profile/Partials/Card.jsx";

export default function Index({auth, cards}) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                    Ваші картки
                </h2>
            }>
            <Head title="Профіль"/>

            <div className="py-12">
                <div className="flex flex-col max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {cards.map((card) =>
                        <Card card={card} key={card.id}></Card>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
