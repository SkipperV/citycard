import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, router, useForm} from '@inertiajs/react';
import SelectInput from "@/Components/SelectInput.jsx";
import {useTranslation} from "react-i18next";
import {useState} from "react";
import {useMutation} from "@tanstack/react-query";

export default function Create({auth, status, city}) {
    const {t} = useTranslation();

    const [routeNumber, setRouteNumber] = useState("");
    const [transportType, setTransportType] = useState("");
    const [endpoint_1, setEndpoint_1] = useState("");
    const [endpoint_2, setEndpoint_2] = useState("");
    const [errors, setErrors] = useState({});

    const mutation = useMutation({
        mutationFn: async ({routeNumber, transportType, endpoint_1, endpoint_2}) => {
            return await axios.post(route('api.transport.store', {city: city.id}), {
                route_number: routeNumber,
                transport_type: transportType,
                route_endpoint_1: endpoint_1,
                route_endpoint_2: endpoint_2
            });
        },
        onSuccess: () => {
            setErrors({});
            router.visit(route('transport.index', {city: city.id}));
        },
        onError: (error) => {
            setErrors(error.response.data.errors);
        }
    });

    const submit = (e) => {
        e.preventDefault();
        mutation.mutate({routeNumber, transportType, endpoint_1, endpoint_2});
    };

    const transportTypeOptions = [
        'bus',
        'electric'
    ];

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <Link href={route('transport.index', {city: city.id})}>
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
                        {t("transport.title.create")} {city.name}
                    </h2>
                </div>
            }>
            <Head title={`${t("transport.title.create")} ${city.name}`}/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="max-w-7xl mx-auto">
                <div className="w-96 mx-auto">
                    <form onSubmit={submit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="route_number" className="dark:text-gray-300"
                                        value={t("transport.field.route_number")}/>

                            <TextInput
                                id="route_number"
                                type="text"
                                name="route_number"
                                value={routeNumber}
                                className="mt-1 block w-full"
                                onChange={(e) => setRouteNumber(e.target.value)}
                            />
                            {
                                errors.route_number && errors.route_number.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="transport_type" className="dark:text-gray-300"
                                        value={t("transport.field.transport_type")}/>

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
                            <InputLabel htmlFor="route_endpoint_1" className="dark:text-gray-300"
                                        value={t("transport.field.endpoint_1")}/>

                            <TextInput
                                id="route_endpoint_1"
                                type="text"
                                name="route_endpoint_1"
                                value={endpoint_1}
                                className="mt-1 block w-full"
                                onChange={(e) => setEndpoint_1(e.target.value)}
                            />
                            {
                                errors.route_endpoint_1 && errors.route_endpoint_1.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="route_endpoint_2" className="dark:text-gray-300"
                                        value={t("transport.field.endpoint_2")}/>

                            <TextInput
                                id="route_endpoint_2"
                                type="text"
                                name="route_endpoint_2"
                                value={endpoint_2}
                                className="mt-1 block w-full"
                                onChange={(e) => setEndpoint_2(e.target.value)}
                            />
                            {
                                errors.route_endpoint_2 && errors.route_endpoint_2.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4 flex">
                            <PrimaryButton className="mx-auto" disabled={mutation.isPending}>
                                {t("operations.create")}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
