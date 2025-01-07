import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, router} from '@inertiajs/react';
import SelectInput from "@/Components/SelectInput.jsx";
import {useTranslation} from "react-i18next";
import {useState} from "react";
import {useMutation} from "@tanstack/react-query";
import {transportTypeOptions} from "@/Constants/transportTypeOptions.js";
import {ticketTypeOptions} from "@/Constants/ticketTypeOptions.js";

export default function Create({auth, status, city}) {
    const {t} = useTranslation();

    const [transportType, setTransportType] = useState('');
    const [ticketType, setTicketType] = useState('');
    const [price, setPrice] = useState('');
    const [errors, setErrors] = useState({});

    const mutation = useMutation({
        mutationFn: async ({transportType, ticketType, price}) => {
            return await axios.post(route('api.tickets.store', {city: city.id}), {
                transport_type: transportType,
                ticket_type: ticketType,
                price: price
            });
        },
        onSuccess: () => {
            setErrors({});
            router.visit(route('tickets.index', {city: city.id}));
        },
        onError: (error) => {
            setErrors(error.response.data.errors);
        }
    });

    const submit = (e) => {
        e.preventDefault();
        mutation.mutate({transportType, ticketType, price});
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <Link href={route('tickets.index', {city: city.id})}>
                        <svg className="absolute left-3 top-1 h-4 text-gray-800 hover:cursor-pointer dark:text-white"
                             aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 8 14">
                            <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                  d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                        </svg>
                    </Link>
                    <h2 className="absolute left-1/2 transform -translate-x-1/2 top-0 h-full font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                        {t('tickets.title.create')} {city.name}
                    </h2>
                </div>
            }>
            <Head title={`${t('tickets.title.create')} ${city.name}`}/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="max-w-7xl mx-auto">
                <div className="w-96 mx-auto">
                    <form onSubmit={submit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="transport_type" className="dark:text-gray-300"
                                        value={t('tickets.field.transport_type')}/>

                            <SelectInput
                                id="transport_type"
                                className="mt-1 block w-full"
                                options={transportTypeOptions}
                                object="transport"
                                value={transportType}
                                onChange={(e) => setTransportType(e.target.value)}
                            />
                            {
                                errors.transport_type && errors.transport_type.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="ticket_type" className="dark:text-gray-300"
                                        value={t('tickets.field.ticket_type')}/>

                            <SelectInput
                                id="ticket_type"
                                className="mt-1 block w-full"
                                options={ticketTypeOptions}
                                object="tickets"
                                value={ticketType}
                                onChange={(e) => setTicketType(e.target.value)}
                            />
                            {
                                errors.ticket_type && errors.ticket_type.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="price" className="dark:text-gray-300"
                                        value={t('tickets.field.price')}/>

                            <TextInput
                                id="price"
                                type="text"
                                name="price"
                                value={price}
                                className="mt-1 block w-full"
                                onChange={(e) => setPrice(e.target.value)}
                            />
                            {
                                errors.price && errors.price.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4 flex">
                            <PrimaryButton className="mx-auto" disabled={mutation.isPending}>
                                {t('operations.create')}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
