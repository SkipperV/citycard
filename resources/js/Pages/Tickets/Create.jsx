import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, useForm} from '@inertiajs/react';
import SelectInput from "@/Components/SelectInput.jsx";

export default function Create({auth, status, city}) {
    const handleRedirect = () => {
        router.visit(route('tickets.index', city.id));
    }

    const {data, setData, post, processing, errors} = useForm({
        transport_type: '',
        ticket_type: '',
        price: '',
    });

    const transportTypeOptions = [
        'Автобус',
        'Тролейбус',
    ];

    const ticketTypeOptions = [
        'Стандартний',
        'Дитячий',
        'Студентський',
        'Пільговий',
        'Спеціальний',
    ];

    const submit = (e) => {
        e.preventDefault();

        post(route('tickets.store', city.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <svg onClick={handleRedirect}
                         className="absolute left-3 top-1 h-4 text-gray-800 hover:cursor-pointer dark:text-white"
                         aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 8 14">
                        <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                              d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                    </svg>
                    <h2 className="absolute left-1/2 transform -translate-x-1/2 top-0 h-full font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                        Створення нового типу квитка ({city.name})
                    </h2>
                </div>
            }>
            <Head title="Створити квиток"/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="max-w-7xl mx-auto">
                <div className="w-96 mx-auto">
                    <form onSubmit={submit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="transport_type" className="dark:text-gray-300" value="Тип транспорту"/>

                            <SelectInput
                                id="transport_type"
                                className="mt-1 block w-full"
                                options={transportTypeOptions}
                                value={data.transport_type}
                                onChange={(e) => setData('transport_type', e.target.value)}
                            />

                            <InputError message={errors.transport_type} className="mt-2"/>
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="ticket_type" className="dark:text-gray-300" value="Тип квитка"/>

                            <SelectInput
                                id="ticket_type"
                                className="mt-1 block w-full"
                                options={ticketTypeOptions}
                                value={data.ticket_type}
                                onChange={(e) => setData('ticket_type', e.target.value)}
                            />

                            <InputError message={errors.ticket_type} className="mt-2"/>
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="price" className="dark:text-gray-300" value="Ціна"/>

                            <TextInput
                                id="price"
                                type="text"
                                name="price"
                                value={data.price}
                                className="mt-1 block w-full"
                                onChange={(e) => setData('price', e.target.value)}
                            />

                            <InputError message={errors.price} className="mt-2"/>
                        </div>

                        <div className="mt-4 flex">
                            <PrimaryButton className="mx-auto" disabled={processing}>
                                Створити
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
