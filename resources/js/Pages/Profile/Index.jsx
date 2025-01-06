import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from "@inertiajs/react";
import Card from "@/Pages/Profile/Partials/Card.jsx";
import {useTranslation} from "react-i18next";
import {useQuery} from "@tanstack/react-query";

const retrieveCards = async () => {
    const response = await axios.get(route('api.user.cards.index'));

    return response.data;
}

export default function Index({auth}) {
    const {t} = useTranslation();

    const {data: cards, error, isLoading} = useQuery({
        queryKey: ['cardsData', auth.user.id],
        queryFn: () => retrieveCards()
    })

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                    {t("home.title")}
                </h2>
            }>
            <Head title={t("home.title")}/>

            <div className="py-12">
                <div className="flex flex-col max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {!isLoading && !error && cards.data.map((card) =>
                        <Card card={card} key={card.id}/>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
