import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, router, useForm} from '@inertiajs/react';
import SelectInput from "@/Components/SelectInput.jsx";

export default function Create({auth, status, city}) {
    const handleRedirect = () => {
        router.visit(route('transport.index', city.id));
    }

    const {data, setData, post, processing, errors} = useForm({
        route_number: '',
        transport_type: '',
        route_endpoint_1: '',
        route_endpoint_2: '',
    });

    const transportTypeOptions = [
        'Автобус',
        'Тролейбус',
    ];

    const submit = (e) => {
        e.preventDefault();

        post(route('transport.store', city.id));
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
                        Створення нового маршруту ({city.name})
                    </h2>
                </div>
            }>
            <Head title="Створити маршрут"/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="max-w-7xl mx-auto">
                <div className="w-96 mx-auto">
                    <form onSubmit={submit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="route_number" className="dark:text-gray-300" value="Номер маршруту"/>

                            <TextInput
                                id="route_number"
                                type="text"
                                name="route_number"
                                value={data.route_number}
                                className="mt-1 block w-full"
                                onChange={(e) => setData('route_number', e.target.value)}
                            />

                            <InputError message={errors.route_number} className="mt-2"/>
                        </div>

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
                            <InputLabel htmlFor="route_endpoint_1" className="dark:text-gray-300" value="Кінцева 1"/>

                            <TextInput
                                id="route_endpoint_1"
                                type="text"
                                name="route_endpoint_1"
                                value={data.route_endpoint_1}
                                className="mt-1 block w-full"
                                onChange={(e) => setData('route_endpoint_1', e.target.value)}
                            />

                            <InputError message={errors.route_endpoint_1} className="mt-2"/>
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="route_endpoint_2" className="dark:text-gray-300" value="Кінцева 2"/>

                            <TextInput
                                id="route_endpoint_2"
                                type="text"
                                name="route_endpoint_2"
                                value={data.route_endpoint_2}
                                className="mt-1 block w-full"
                                onChange={(e) => setData('route_endpoint_2', e.target.value)}
                            />

                            <InputError message={errors.route_endpoint_2} className="mt-2"/>
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
