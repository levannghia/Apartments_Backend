import React, { useRef, useState } from "react";
import Authenticated from "@/Layouts/Authenticated";
import { Head, useForm } from "@inertiajs/inertia-react";
import axios from "axios";
import { Editor } from '@tinymce/tinymce-react';
import SelectCountry from "@/Components/SelectCountry";
import InputForm from "@/Components/inputForm";

export default function Create(props) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        website: '',
        phone: '',
        about: '',
        zip: '',
        city: '',
        state: '',
        street: '',
    })
    const editorRef = useRef(null);
    const [value, setValue] = useState(null);
    const [activeIndex, setActiveIndex] = useState(0);
    const [state, setState] = useState([]);
    const [street, setStreet] = useState([]);
    const handleChangeCity = async (e) => {
        setData('city', e.target.value);
        const { data } = await axios.get(route('country.state'), {
            params: {
                id: `${e.target.value}`,
            }
        });

        if (data.data) {
            setState(data.data);
            setStreet([]);
        }
        else {
            setState([]);
        }
    }

    const handleChangeActive = (index) => {
        setActiveIndex(index);
    }

    const handleChangeState = async (e) => {
        setData('state', e.target.value)
        const { data } = await axios.get(route('country.street'), {
            params: {
                id: `${e.target.value}`,
            }
        });
        if (data.data) setStreet(data.data);
        else setStreet([]);
    }

    function submit(e) {
        e.preventDefault()
        post(route('apartment.store'), {
            preserveScroll: true,
        });
    }

    const getBody = () => {
        if (activeIndex === 0) {
            return (
                <>
                    <div className="md:basis-3/5">
                        <InputForm error={errors.name} name="Name" value={data.name} required={true} isFocused={true} handleChange={e => setData('name', e.target.value)}/>
                        <InputForm error={errors.website} autoComplete={true} name="Website" value={data.website} handleChange={e => setData('website', e.target.value)}/>
                        <InputForm error={errors.phone} autoComplete={true} name="Phone" value={data.phone} handleChange={e => setData('phone', e.target.value)}/>
                        <div className="mb-5">
                            <label
                                htmlFor="message"
                                className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                About
                            </label>
                            <Editor
                                apiKey='66y1xewaxqzfezu1ryf9nq34zgmcbjzazz3cyvamp01t16bl'
                                // onInit={(evt, editor) => editorRef.current = editor}
                                // initialValue="<p>This is the initial content of the editor.</p>"
                                onEditorChange={(newValue, editor) => {
                                    setValue(newValue);
                                    setData('about', editor.getContent({ format: 'text' }));
                                }}
                                init={{
                                    height: 400,
                                    menubar: false,
                                    plugins: [
                                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                                        'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                                    ],
                                    toolbar: 'undo redo | blocks | ' +
                                        'bold italic forecolor | alignleft aligncenter ' +
                                        'alignright alignjustify | bullist numlist outdent indent | ' +
                                        'removeformat | help',
                                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                                }}
                            />
                        </div>
                    </div>
                    <div className="md:basis-2/5">
                        <SelectCountry name='city' data={props.city} value={data.city} onChange={handleChangeCity} type={['Thành phố Trung ương', 'Tỉnh']} error={errors.city}/>
                        <SelectCountry name='state' data={state} value={data.state} onChange={handleChangeState} type={['Thành phố', 'Quận', 'Huyện']} error={errors.state}/>
                        <SelectCountry name='street' data={street} value={data.street} onChange={(e) => setData('street', e.target.value)} type={['Xã', 'Phường', 'Thị trấn']} error={errors.street}/>
                        <InputForm autoComplete={true} error={errors.zip} type="number" name="Zip" value={data.zip} handleChange={e => setData('zip', e.target.value)}/>
                    </div>
                </>
            )
        }
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create Apartment</h2>}
        >
            <Head title="Create Apartment" />
            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                                <ul className="flex flex-wrap -mb-px">
                                    <li className="me-2">
                                        <a
                                            href="#"
                                            onClick={() => handleChangeActive(0)}
                                            className={`inline-block p-4 ${activeIndex === 0 ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 border-transparent'} border-b-2  rounded-t-lg`}
                                            aria-current="page"
                                        >
                                            Information
                                        </a>
                                    </li>
                                    <li className="me-2">
                                        <a
                                            onClick={() => handleChangeActive(1)}
                                            href="#"
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${activeIndex === 1 ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 border-transparent'}`}
                                        >
                                            Apartments
                                        </a>
                                    </li>

                                    <li className="me-2">
                                        <a
                                            onClick={() => handleChangeActive(2)}
                                            href="#"
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${activeIndex === 2 ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 border-transparent'}`}
                                        >
                                            Pets
                                        </a>
                                    </li>
                                    <li className="me-2">
                                        <a
                                            onClick={() => handleChangeActive(3)}
                                            href="#"
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${activeIndex === 3 ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 border-transparent'}`}
                                        >
                                            Features
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            onClick={() => handleChangeActive(4)}
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${activeIndex === 4 ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 border-transparent'}`}
                                        >
                                            Scores
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            onClick={() => handleChangeActive(5)}
                                            href="#"
                                            className={`inline-block p-4 border-b-2 rounded-t-lg ${activeIndex === 5 ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 border-transparent'}`}
                                        >
                                            Reviews
                                        </a>
                                    </li>
                                </ul>
                                <div className="pt-4">
                                    <form className="mx-auto" onSubmit={submit}>
                                        <div className="flex md:flex-row flex-col md:space-x-6">
                                            {getBody()}
                                        </div>
                                        <button
                                            disabled={processing}
                                            type="submit"
                                            className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        >
                                            Lưu
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    )
}
